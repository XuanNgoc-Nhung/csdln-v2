// ==UserScript==
// @name         New Userscript
// @namespace    http://tampermonkey.net/
// @version      2024-05-03
// @description  try to take over the world!
// @author       You
// @match        https://gu1vn.net/Home/Index
// @icon         https://www.google.com/s2/favicons?sz=64&domain=gu1vn.net
// @grant        none
// ==/UserScript==
var lv = 2;
var ten_lv = 'Bạch Kim';
(function () {
    'use strict';
    setTimeout(() => {
        demoFunctionFake();
    }, 200);
    function demoFunctionFake() {
        console.error('demofunction');
        let divLv = document.querySelector("body > div.scroll-wrapper.scrollbar-macosx > div.scrollbar-macosx.scroll-content.scroll-scrollx_visible.scroll-scrolly_visible > div.toper > div.toperM.ng-scope > div.memberArea.ng-scope > ul > li:nth-child(1)");
        if (divLv) {
            console.error(divLv);
            divLv.className = 'level'+lv;
        }
        let tenLv = document.querySelector("body > div.scroll-wrapper.scrollbar-macosx > div.scrollbar-macosx.scroll-content.scroll-scrollx_visible.scroll-scrolly_visible > div.toper > div.toperM.ng-scope > div.memberArea.ng-scope > ul > li:nth-child(1) > span");
        console.error(tenLv);
        if (tenLv) {
            tenLv.textContent = ten_lv;
        }

    }


    // Your code here...
})();
