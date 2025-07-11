export default {

    pushState(key, value) {
        if (history.pushState) {
            let url = window.location.href;
            url = this.updateUrlParameter(url, key, value);
            window.history.pushState({path: url}, '', url);
        }
    },

    getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        let regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    },

    updateUrlParameter(uri, key, value) {
        let i = uri.indexOf('#');
        let hash = i === -1 ? '' : uri.substr(i);
        uri = i === -1 ? uri : uri.substr(0, i);
        let re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
        let separator = uri.indexOf('?') !== -1 ? "&" : "?";
        if (!value) {
            uri = uri.replace(new RegExp("([?&]?)" + key + "=[^&]*", "i"), '');
            if (uri.slice(-1) === '?') {
                uri = uri.slice(0, -1);
            }
            if (uri.indexOf('?') === -1) uri = uri.replace(/&/, '?');
        } else if (uri.match(re)) {
            uri = uri.replace(re, '$1' + key + "=" + value + '$2');
        } else {
            uri = uri + separator + key + "=" + value;
        }
        return uri + hash;
    },

    getStatus(status) {
        switch (status) {
            case 0:
                return "Chờ checkin";
            case 1:
                return "Đã checkin";
            case 2:
                return "Chờ checkout";
            case 3:
                return "Đã checkout";
        }
        return "Không rõ";
    },

    convertTime(time) {
        if (isNaN(time)) {
            return "";
        }
        let a = new Date(time);
        let year = a.getFullYear();
        let month = a.getMonth() + 1;
        let date = a.getDate();
        let hour = a.getHours();
        let min = a.getMinutes();
        let sec = a.getSeconds();
        return ((date >= 10 ? date : "0" + date) + '/' + (month >= 10 ? month : "0" + month) + '/' + year + ' ' + (hour >= 10 ? hour : "0" + hour) + ':' + (min >= 10 ? min : "0" + min) + ':' + (sec >= 10 ? sec : "0" + sec));
    },

    getPartName(date) {
        let year = date.getFullYear();
        let month = date.getMonth() + 1;
        let day = date.getDate();
        return parseInt(year + (month >= 10 ? month : "0" + month) + (day >= 10 ? day : "0" + day));
    },

    convertDate(time) {
        if (isNaN(time)) {
            return "";
        }
        let a = new Date(time);
        let year = a.getFullYear();
        let month = a.getMonth() + 1;
        let date = a.getDate();
        return ((date >= 10 ? date : "0" + date) + '/' + (month >= 10 ? month : "0" + month) + '/' + year);
    },

    isNumber(num) {
        if (num === null || num === undefined || isNaN(num)) {
            return false;
        }
        return true;
    },

    checkString(str) {
        return (str !== undefined && str !== null && str.trim() !== "");
    },

    arrayToString(arr, delim) {
        if (!this.isArray(arr)) {
            return "";
        }
        if (!this.checkString(delim)) {
            delim = ",";
        }
        let ret = "";
        for (let i = 0; i < arr.length; i++) {
            if (i > 0) {
                ret += delim;
            }
            ret += arr[i];
        }
        return ret;
    },

    checkData(data) {
        return (data !== undefined && data !== null);
    },

    isArray(what) {
        return Object.prototype.toString.call(what) === '[object Array]';
    },

    calcTotalPage(size, total) {
        let result = total;
        result = Math.floor(total / size);
        const a1 = total % size;
        if (a1 !== 0) {
            result++;
        }
        return result;
    },

    formatMoneyEx(n) {
        var c = 0,
            d = ".",
            t = ",",
            s = n < 0 ? "-" : "",
            i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
            j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    },

    isDate(date) {
        return Object.prototype.toString.call(date) === '[object Date]';
    },

    stringToDate(string) {
        // var parts ='2014-04-03'.split('-');
        let parts = string.split('/');
        let mydate = new Date(parts[2], parts[1] - 1, parts[0]);
        return mydate;
    },

     confirmDialog(content, btnOkTitle, fn) {
        BootstrapDialog.show({
            title: "Thông báo",
            type: BootstrapDialog.TYPE_DEFAULT,
            size: BootstrapDialog.SIZE_SMALL,
            message: content,
            buttons: [
                {
                    label: 'Đóng',
                    action: (dialog) => {
                        dialog.close();
                    }
                },
                {
                    label: btnOkTitle,
                    cssClass: 'btn-primary',
                    action: (dialog) => {
                        dialog.close();
                        if (typeof fn === "function") {
                            fn();
                        }
                    }
                }
            ]
        });
    },

    showDialog(title, content, data, fnOnHide, size) {
        if (size === undefined || size === null) {
            size = BootstrapDialog.SIZE_SMALL;
        }

        BootstrapDialog.show({
            title: title,
            type: BootstrapDialog.TYPE_DEFAULT,
            size: size,
            data: data, //data 0 : 1
            message: content,
            buttons: [
                {
                    hotkey: 13, // Enter.
                    label: 'Đóng',
                    action: (dialog) => {
                        dialog.close();
                    }
                }
            ],
            onhide: (dialogRef) => {
                if (typeof fnOnHide === "function") {
                    var rc = 0;
                    if (data !== null && data !== undefined) {
                        rc = dialogRef.getData("rc");
                    }
                    fnOnHide(rc);
                }
            }
        });
    },

    mangso: ['không', 'một', 'hai', 'ba', 'bốn', 'năm', 'sáu', 'bảy', 'tám', 'chín'],

    dochangchuc(so, daydu) {
        let chuoi = "";
        let chuc = Math.floor(so / 10);
        let donvi = so % 10;
        if (chuc > 1) {
            chuoi = " " + this.mangso[chuc] + " mươi";
            if (donvi === 1) {
                chuoi += " mốt";
            }
        } else if (chuc === 1) {
            chuoi = " mười";
            if (donvi === 1) {
                chuoi += " một";
            }
        } else if (daydu && donvi > 0) {
            chuoi = " lẻ";
        }
        if (donvi === 5 && chuc > 1) {
            chuoi += " lăm";
        } else if (donvi > 1 || (donvi === 1 && chuc === 0)) {
            chuoi += " " + this.mangso[donvi];
        }
        return chuoi;
    },

    docblock(so, daydu) {
        let chuoi = "";
        let tram = Math.floor(so / 100);
        so = so % 100;
        if (daydu || tram > 0) {
            chuoi = " " + this.mangso[tram] + " trăm";
            chuoi += this.dochangchuc(so, true);
        } else {
            chuoi = this.dochangchuc(so, false);
        }
        return chuoi;
    },

    dochangtrieu(so, daydu) {
        let chuoi = "";
        let trieu = Math.floor(so / 1000000);
        so = so % 1000000;
        if (trieu > 0) {
            chuoi = this.docblock(trieu, daydu) + " triệu";
            daydu = true;
        }
        let nghin = Math.floor(so / 1000);
        so = so % 1000;
        if (nghin > 0) {
            chuoi += this.docblock(nghin, daydu) + " nghìn";
            daydu = true;
        }
        if (so > 0) {
            chuoi += this.docblock(so, daydu);
        }
        return chuoi;
    },

    docso(so) {
        if (so === 0) return this.mangso[0];
        let chuoi = "", hauto = "";
        do {
            let ty = so % 1000000000;
            so = Math.floor(so / 1000000000);
            if (so > 0) {
                chuoi = this.dochangtrieu(ty, true) + hauto + chuoi;
            } else {
                chuoi = this.dochangtrieu(ty, false) + hauto + chuoi;
            }
            hauto = " tỷ";
        } while (so > 0);
        return chuoi;
    },
}
