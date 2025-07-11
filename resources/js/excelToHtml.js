(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? factory(exports) :
        typeof define === 'function' && define.amd ? define(['exports'], factory) :
            (global = global || self, factory(global.excel2table = {}));
}(this, function (exports) { 'use strict';

    function createXSLXStyles(styles) {
        let style = document.getElementById("xlsx_generated_styles");
        if (style) {
            style.innerHTML = "";
        } else {
            style = document.createElement("style");
            style.id = "xlsx_generated_styles";
            document.head.appendChild(style);
        }

        style.innerHTML = createCssTable(styles);
    }

    function createCssTable(styles) {
        let result = "";
        let base = (new Date()).valueOf();
        for (let i=0; i<styles.length; i++) {
            const record = styles[i];
            record.id = "s" + (base++);
            let cssString = "";
            for (const key in record) {
                if (key === "format" || key === "id") continue;

                const prop = record[key];
                const name = key.replace(/[A-Z]{1}/g, letter => `-${letter.toLowerCase()}`);
                cssString += `${name}:${prop};`;
            }
            result += `.excel2table td.${record.id}{${cssString}}\n`;
        }
        return result;
    }

    const formatProp = (v, prettify) => prettify && v < 10 ? "0" + v : v;

    const getDateProps = d => ({
        y: d.getFullYear(),
        m: d.getMonth() + 1,
        d: d.getDate(),
        h: d.getHours(),
        min: d.getMinutes(),
        s: d.getSeconds(),
        w: d.getDay()
    });

    const month = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December"
    ];

    const weekdays =  ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Monday"];

    const specialDateSymbols = {
        y: true,
        m: true,
        d: true,
        h: true,
        s: true
    };

    function isDateFormat(format) {
        if (!format) {
            return false;
        }
        let count = 0;
        let waitCloseBracket = false;
        for (let i=0; i<format.length; i++) {
            if (waitCloseBracket) {
                waitCloseBracket = format[i] !== "]";
                continue;
            }
            if (format[i] === "[") {
                waitCloseBracket = true;
            }
            if (specialDateSymbols[format[i]]) {
                count += 1;
                if (count > 1) {
                    return true;
                }
            }
        }
        return false;
    }

    const baseDate = new Date(1899, 11, 30, 0, 0, 0);
    const baseOffset = baseDate.getTimezoneOffset();
    const baseTimestamp = baseDate.getTime();

    function offsetToDate(offset) {
        return new Date(baseTimestamp + (offset * 24 * 60 + baseOffset) * 60 * 1000);
    }


    function tryFormatAsDate(value, format) {
        if (!isDateFormat(format)) {
            return value;
        }

        const date = offsetToDate(value);
        const {m, d, y, h, min, s, w} = getDateProps(date);
        let afterH = false;
        let waitCloseBracket = false;
        let result = "";

        const ampm = format.indexOf("AM/PM");
        if (ampm !== -1) {
            format = format.slice(0, ampm) + (h < 12 ? "AM" : "PM") + format.slice(ampm);
        }

        for (let i=0; i<format.length; i++) {
            if (waitCloseBracket) {
                waitCloseBracket = format[i] !== "]";
                continue;
            }
            switch (format[i]) {
                case "[":
                    waitCloseBracket = true;
                    break;
                case "y":
                    if (format.substr(i, 4) === "yyyy") {
                        result += y;
                        i += 3;
                    } else if (format[i + 1] === "y") {
                        result += formatProp(y % 100, true);
                        i++;
                    }
                    break;
                case "m":
                    const isMNext = format[i + 1] === "m";
                    if (afterH) {
                        result += formatProp(min, isMNext);
                        if (isMNext) {
                            i++;
                        }
                    } else {
                        if (format.substr(i, 4) === "mmmm") {
                            result += month[m - 1];
                            i += 3;
                        } else if (format.substr(i, 3) === "mmm") {
                            result += month[m - 1].substr(0, 3);
                            i += 2;
                        } else {
                            result += formatProp(m, isMNext);
                            if (isMNext) {
                                i++;
                            }
                        }
                    }
                    break;
                case "d":
                    if (format.substr(i, 4) === "dddd") {
                        result += weekdays[w];
                        i += 3;
                    } else if (format.substr(i, 3) === "ddd") {
                        result += weekdays[w].substr(0, 3);
                        i += 2;
                    } else {
                        const isDNext = format[i + 1] === "d";
                        result += formatProp(d, isDNext);
                        if (isDNext) {
                            i++;
                        }
                    }
                    break;
                case "h":
                    afterH = true;
                    const isHNext = format[i + 1] === "h";
                    result += formatProp(ampm !== -1 ? h % 12 || 12 : h, isHNext);
                    if (isHNext) {
                        i++;
                    }
                    break;
                case "s":
                    const isSNext = format[i + 1] === "s";
                    result += formatProp(s, isSNext);
                    if (isSNext) {
                        i++;
                    }
                    break;
                case "@":
                case ";":
                case "\\":
                    break;
                default:
                    result += format[i];
            }
        }
        return result;
    }

    function formatCell(value, format) {
        if (isNaN(value)) {
            return value;
        }
        const float = parseFloat(value);
        switch (format) {
            case "General":
                return value;
            case "0.00":
                return value.toFixed(2);
            case "0%":
                return Math.round(float) + "%";
            case "0.00%":
                return float.toFixed(2) + "%";
            case "0.00E+00":
                const e = Math.ceil(Math.log(10, float)) + 1;
                return `${(float / Math.pow(10, e)).toFixed(2)}E${e > 0 ? "+" : ""}${formatProp(e, true)}`
            default:
                return tryFormatAsDate(float, format);
        }
    }

    let api;
    const calls = {};

    let idcount = 1;
    function id(){
        return idcount++;
    }

    function getWorker(url){
        if (api) return api;

        const wk = new Worker(url);

        wk.addEventListener("message", e => {
            if (e.data.type === "ready"){
                const promise = calls[e.data.uid];
                promise.resolve(e.data);
                delete calls[e.data.uid];
            }
        });

        api = {
            send: function(data){
                var uid = id();
                return new Promise(function(resolve, reject){
                    calls[uid] = { resolve, reject };
                    data.uid = uid;
                    wk.postMessage(data);
                });
            }
        };

        return api;
    }

    function render(container, data, config) {
        config = config || {};

        if (typeof container === "string"){
            container = document.querySelector(container);
        }

        let url = config.worker;
        if (!url){
            url = window.URL.createObjectURL(new Blob([
                "importScripts('https://cdn.dhtmlx.com/libs/excel2json/1.0/worker.js');"
            ], { type: "text/javascript" }));
        }

        return getWorker(url).send({ type: "convert", data })
            .then(result => renderJSON(container, result.data, result.styles, config));
    }

    function renderJSON(container, data, styles, config){
        const {
            cells,
            cols,
            rows,
            name,
            merged
        } = data[0];

        createXSLXStyles(styles);
        applyMerges(cells, merged);

        let html = "<table class='excel2table'><tr>";
        if (config.scales){
            html += "<th class='scale-x-cell'></td>";
            for (let j=0; j<cols.length; j++){
                html += `<th style='width:${cols[j].width}px;' class='scale-x-cell'>${getLetterFromNumber(j+1)}</td>`;
            }
        } else {
            for (let j=0; j<cols.length; j++){
                html += `<th style='width:${cols[j].width}px;'></td>`;
            }
        }
        html += "</tr>";

        for (let i=0; i<rows.length; i++) {
            const rowNumber = i + 1;
            html += `<tr style='height: ${rows[i].height}px'>`;
            if (config.scales){
                html += `<td class='scale-y-cell'>${rowNumber}</td>`;
            }

            for (let j=0; j<cols.length; j++) {
                html += createCell(cells[i][j], styles);
            }
            html+="</tr>";
        }
        html+="</table>";

        container.innerHTML = html;
    }

    function createCell(cell, styles) {
        if (cell === -1) return "";

        let spans = "";
        let text = "";
        let style = styles[0];

        if (cell){
            if (cell.s){
                style = styles[cell.s];
            }
            if (cell.v){
                text = style.format ? formatCell(cell.v, style.format) : cell.v;
            }
            if (cell.colspan || cell.rowspan){
                spans = ` colspan="${cell.colspan}" rowspan="${cell.rowspan}" `;
            }
        }

        return `<td class="${style.id}"${spans}>${text||""}</td>`;
    }

    function getLetterFromNumber(num) {
        num = --num;
        const numeric = num % 26;
        const letter = String.fromCharCode(65 + numeric);
        const group = Math.floor(num / 26);
        if (group > 0) {
            return getLetterFromNumber(group) + letter;
        }
        return letter;
    }

    function applyMerges(cells, merged){
        for (let i=0; i<merged.length; i++){
            const { from, to } = merged[i];
            const cell = cells[from.row][from.column] || { v: null, s: 0 };
            cell.colspan = to.column - from.column + 1;
            cell.rowspan = to.row - from.row + 1;

            for (let x=from.row; x<=to.row; x++){
                for (let y=from.column; y<=to.column; y++){
                    cells[x][y] = -1;
                }
            }

            cells[from.row][from.column] = cell;
        }
    }

    exports.render = render;
    exports.renderJSON = renderJSON;

    Object.defineProperty(exports, '__esModule', { value: true });

}));
