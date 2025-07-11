
/* global BootstrapDialog */

//Game
var kGameBaCay = 100;
var kGameBaCayChuong = 101;
var kGamePhom = 102;
var kGameXiTo = 103;
var kGameTienLenMienBac = 104;
var kGameTienLenMienNam = 105;
var kGameLieng = 106;
var kGameCoTuong = 107;
var kGameChan = 109;
var kGameCoUp = 110;
var kGameSam = 111;
var kGameTLMNDemLa = 112;
var kGameTaiXiu = 113; // dang nham thanh tai xiu
var kGameXocDia = 114;
var kGameQuayThuong = 115;
var kGameDemLaSolo = 116;
var kGameSamSolo = 117;
var kGameTaiXiuMini = 128;
var kGameMinPocker = 130;
var kGameBauTom = 131;
var kGameCaoThap = 132;
var kGameTomCuaCa = 133;
var kGameQuayThuong = 134;
var kGameMauBinh = 137;
var kGamePoker = 138;
var kGameCatte = 140;
var kGameBaDoi = 250;
var kGameSlot = 139;

// OS
var OS_ID_ANDROID = 1;
var OS_ID_IOS = 2;
var OS_ID_WINDOWSPHONE = 3;
var OS_ID_WEB = 4;

// Nha mang
var CELLCARD = 1;
var METFONE = 2;
var SMART = 3;

var ADMIN_CANCELED = "ADMIN_CANCELED";
var USER_REQUESTING = "USER_REQUESTING";
var ADMIN_APPROVED = "ADMIN_APPROVED";
var ADMIN_PHAT = "ADMIN_PHAT";

var ROOM_TYPE_GOLD = 0;
var ROOM_TYPE_SILVER = 0;

function getRoomTypeName(roomType) {
    switch (parseInt(roomType)) {
        case ROOM_TYPE_GOLD:
            return "Zen";
        default :
            return "Gold";
    }
}

function getGameName(idx) {
    var name = "";
    switch (parseInt(idx)) {
        case kGameTomCuaCa:
            name = "Bầu tôm";
            break;
        case kGameCatte:
            name = "Catte";
            break;
        case kGameQuayThuong:
            name = "VQMM";
            break;
        case kGameBaDoi :
            name = "Ba đôi";
            break;
        case kGameTLMNDemLa:
            name = "TLDL";
            break;
        case kGameDemLaSolo :
            name = "TLDL Solo";
            break;
        case kGameTaiXiuMini :
            name = "Tài Xỉu Mini";
            break;
        case kGameMinPocker :
            name = "Poker Mini";
            break;
        case kGamePoker :
            name = "Poker";
            break;
        case kGameSlot :
            name = "Slot Machine";
            break;
        case kGameMauBinh :
            name = "Mậu Binh";
            break;
        case kGameXocDia :
            name = "Xóc Đĩa";
            break;
        case 999:
            name = "Sảnh chính ";
            break;
    }
    return name;
}

function getNameGameShort(idx) {

}

function getNameNhaMang(idx) {
    switch (idx) {
        case CELLCARD:
            return "Cellcard";
        case METFONE:
            return "Metfone";
        case SMART:
            return "Smart";
        default :
            return "Unknown";
    }
}

function getNameOS(idx) {
    switch (idx) {
        case OS_ID_ANDROID:
            return "Android";
        case OS_ID_IOS:
            return "iOS";
        case OS_ID_WINDOWSPHONE:
            return "WindowPhone";
        case OS_ID_WEB:
            return "Web";
        default :
            return "";
    }
}

var CREDIT_BALANCE = 1;
var DEBIT_BALANCE = 2;
var RECEIVE_GIFT_CODE = 3;
var TRANSFER_BALANCE_TO_USER = 1004;
var RECEIVER_BALANCE_FROM_USER = 1005;
var FEE_TRANSFER_BALANCE_TO_USER = 1006;
var VIP_POINT_TO_BALANCE = 1007;
var BONUS_ACTIVE_PHONE_BY_INVITE_FRIEND = 1008;
var BONUS_RECHARGE_BY_INVITE_FRIEND = 1009;
var BONUS_RECHARGE_WHEN_INVITE_FRIEND = 1010;
var BONUS_ACTIVE_NEW_PHONE = 1011;
var VIP_POINT_TO_BALANCE_END_MONTH = 1012;
var BONUS_VIP_EVERY_MONTH = 1013;
var OTP_FEE = 1014;
var TRANSFER_TO_KET_SAT = 1015;
var TRANSFER_FROM_KET_SAT = 1016;
var SELL_GOLD_TO_DAI_LY = 1017;
var RETRIEVE_BALANCE_FROM_DAI_LY = 1018;
var BALANCE_RECHARGE = 1019;
var START_BALANCE_REGISTER = 1020;
var BUY_GOLD_FROM_PARTNER = 2001;
var RETRIEVE_GOLD_BY_PARTNER = 2002;
var PARTNER_REFUSE_BUY_GOLD = 2003;
var ADMIN_ADD_MONEY_TO_USER = 4000;

function getNameTranType(type) {
    switch (parseInt(type)) {
        case CREDIT_BALANCE:
            return "Thắng game";
        case DEBIT_BALANCE:
            return "Bet game";
        case RECEIVE_GIFT_CODE:
            return "Gift Code";
        case TRANSFER_BALANCE_TO_USER:
            return "Chuyển cho user";
        case FEE_TRANSFER_BALANCE_TO_USER:
            return "Phí chuyển user";
        case VIP_POINT_TO_BALANCE:
            return "Đổi Vip Point";
        case BONUS_ACTIVE_PHONE_BY_INVITE_FRIEND:
            return "Giới thiệu - active phone";
        case BONUS_RECHARGE_BY_INVITE_FRIEND:
            return "Giới thiệu - first recharge";
        case OTP_FEE:
            return "Phế OTP";
        case ADMIN_ADD_MONEY_TO_USER:
            return "Admin cộng trừ";
        case RECEIVER_BALANCE_FROM_USER:
            return "Nhận tiền chuyển từ người chơi khác";

    }
    return type;
}

Number.prototype.formatMoneyEx = function (c) {
    var n = this,
            c = isNaN(c = Math.abs(c)) ? 0 : c,
            d = ".",
            t = ",",
            s = n < 0 ? "-" : "",
            i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
            j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

function formatFloat(c){
    
}

function getNow() {
    var today = new Date();
    return getDate(today);
}

function getDate(date) {
    var dd = date.getDate();
    var mm = date.getMonth() + 1; //January is 0!
    var yyyy = date.getFullYear();
    if (dd < 10) {
        dd = '0' + dd;
    }
    if (mm < 10) {
        mm = '0' + mm;
    }
    var s = dd + '/' + mm + '/' + yyyy;
    return s;
}

function getFullDateTime(date) {
    var dd = date.getDate();
    var mm = date.getMonth() + 1; //January is 0!
    var yyyy = date.getFullYear();
    var HH = date.getHours();
    var min = date.getMinutes();
    var second = date.getSeconds();

    if (dd < 10) {
        dd = '0' + dd;
    }
    if (mm < 10) {
        mm = '0' + mm;
    }
    if (HH < 10) {
        HH = '0' + HH;
    }
    if (min < 10) {
        min = '0' + min;
    }
    if (second < 10) {
        second = '0' + second;
    }
    var s = dd + '/' + mm + '/' + yyyy + " " + HH + ":" + min + ":" + second;
    return s;
}

function getDayBefore(numOfdayBefore) {
    var d = new Date();
    d.setDate(d.getDate() - numOfdayBefore);
    return getDate(d);
}

function yyyyMMddToddMMyyyy(dateString) {
    //2016/03/30
    var s = dateString.toString();
    var year = s.substring(0, 4);
    var month = s.substring(5, 7);
    var day = s.substring(8, 10);
    return day + "/" + month + "/" + year;
}

function yyyyMMToMMyyyy(dateString) {
    var s = dateString.toString();
    var year = s.substring(0, 4);
    var month = s.substring(4, 6);
    return month + "/" + year;
}

///2016/07/18 -> yyyy-mm-dd
function convertDate1(dateString) {
    var s = dateString.toString();
    var year = s.substring(0, 4);
    var month = s.substring(5, 7);
    var day = s.substring(8, s.length);
    return year + "-" + month + "-" + day;
}

function convertDate2(dateString) {
    var s = dateString.toString();
    var year = s.substring(0, 4);
    var month = s.substring(5, 7);
    var day = s.substring(8, s.length);
    return day + "/" + month + "/" + year;
}

function convertDate3(date) {
    var year = date.getFullYear();
    var month = date.getMonth() + 1;
    var day = date.getDate();
    return (day < 10 ? ("0" + day) : day) + "/" + (month < 10 ? ("0" + month) : month) + "/" + year;
}


/**
 *
 * @param {String} date : vi du '20160727' - yyyymmdd
 * @returns {String}
 */
function convertDate4(date) {
    //20160727
//    console.log("date=" + date);
    var s = date.toString();
    var year = s.substring(0, 4);
    var month = s.substring(4, 6);
    var day = s.substring(6, 8);
    return day + "/" + month + "/" + year;
}


// dd/MM/yyyy HH:mm:ss -> yyyy/MM/dd HH:mm:ss
function convertDate5(a) {
    var d = a.split(" ");
    var date = d[0].split('/');
    return date[2] + "/" + date[1] + "/" + date[0] + " " + d[1];
}

// dd/MM/yyyy HH:mm -> yyyy/MM/dd HH:mm
function convertDate6(a) {
    var d = a.split(" ");
    var date = d[0].split('/');
    return date[2] + "/" + date[1] + "/" + date[0] + " " + d[1];
}

// dd/MM/yyyy -> yyyy/MM/dd
function convertDate7(a) {
    var date = a.split('/');
    return date[2] + "/" + date[1] + "/" + date[0];
}

function validateDate(str) {
    var t = str.match(/^(\d{2})\/(\d{2})\/(\d{4})$/);
    if (t === null)
        return false;
    var d = parseInt(t[1]), m = parseInt(t[2], 10), y = parseInt(t[3], 10);
    //below should be more acurate algorithm
    if (m >= 1 && m <= 12 && d >= 1 && d <= 31) {
        return true;
    }
    return false;
}

function validateUserName(id) {
    if (id === undefined || id === null || id.trim().length < 3) {
        return false;
    }
    return true;
}

function checkString(str) {
    if (str === undefined || str === null || str.trim().length === 0) {
        return false;
    }
    return true;
}

/**
 *
 * @param {String} msg
 * @returns {stdout}
 */
function log(msg) {
    console.log(msg);
}

function ddlog(msg) {
    console.log(msg);
}

/**
 *
 * @param {String} title
 * @param {String} content
 * @param {Json} data
 * @param {function} fnOnHide
 * @param {type} size
 * @returns {undefined}
 */
function showDialog(title, content, data, fnOnHide, size) {
    hideAllModal();
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
                action: function (dialog) {
                    dialog.close();
                }
            }
        ],
        onhide: function (dialogRef) {
            if (typeof fnOnHide === "function") {
                var rc = 0;
                if (data !== null && data !== undefined) {
                    rc = dialogRef.getData("rc");
                }
                fnOnHide(rc);
            }
        }
    });
}

/**
 *
 * @param {String} content
 * @param {String} btnOkTitle
 * @param {function} fn
 * @returns {undefined}
 */
function confirmDialog(content, btnOkTitle, fn) {
    hideAllModal();
    BootstrapDialog.show({
        title: "Thông báo",
        type: BootstrapDialog.TYPE_DEFAULT,
        size: BootstrapDialog.SIZE_SMALL,
        message: content,
        buttons: [
            {
                label: 'Đóng',
                action: function (dialog) {
                    dialog.close();
                }
            },
            {
                label: btnOkTitle,
                cssClass: 'btn-primary',
                action: function (dialog) {
                    dialog.close();
                    if (typeof fn === "function") {
                        fn();
                    }
                }
            }
        ]
    });
}

function showConfirm(content, btnOkTitle) {
    hideAllModal();
    document.getElementById("content_confirm").innerHTML = content;
    if (btnOkTitle !== undefined) {
        $("#confirm_dilog_btn_ok").text(btnOkTitle);
    }
    $("#confirmDialog").modal();
}

function showLoading(state) {
    hideAllModal();

    if (state === undefined || state === null) {
        state = false;
    }

    if (state) {
        $("#mdLoading").modal("show");
    } else {
        $("#mdLoading").modal("hide");
    }
}

function hideAllModal() {
    $("#globalModal").modal("hide");
    $("#mdLoading").modal("hide");
    $("#confirmDialog").modal("hide");
}

function showProgress() {
    hideAllModal();
    $("#mdLoading").modal({
        backdrop: "static",
        show: true
    });
}

function hideProgress() {
    $("#mdLoading").modal("hide");
}

function GetParameterValues(param) {
    var url = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < url.length; i++) {
        var urlparam = url[i].split('=');
        if (urlparam[0] === param) {
            return decodeURIComponent(urlparam[1].replace(/\+/g, ' '));
        }
    }
    return null;
}

function getValueInQueryString(str, param) {
    var url = str.split("&");
    for (var i = 0; i < url.length; i++) {
        var urlparam = url[i].split('=');
        if (urlparam[0] === param) {
            return urlparam[1];
        }
    }
    return "";
}

function createQueryString(obj) {
    var queryString = "";
    if (obj !== undefined && obj !== null) {
        for (var x in obj) {
            queryString += x;
            queryString += "=";
            queryString += obj[x];
            queryString += "&";
        }
        queryString.trim();
        if (queryString.length > 0) {
            queryString = queryString.substring(0, queryString.length - 1);
        }
    }
    return queryString;
}

function convertQueryStringToJson(s) {
    var obj = {};
    if (s !== undefined && s !== null && s.length > 0) {
        var queryarray = s.split("&");
        for (var i = 0; i < queryarray.length; i++) {
            var urlparam = queryarray[i].split('=');
            if (urlparam.length === 2) {
                obj[urlparam[0]] = decodeURIComponent(urlparam[1].replace(/\+/g, ' '));
            }
        }
    }
    return obj;
}

function parseToString(obj) {
    var s = "";
    for (var key in obj) {
        s += key + "=" + obj[key] + ";";
    }
    s.trim();
    if (s.length > 0)
        s = s.substring(0, s.length - 1);
    return s;
}

/**
 *
 * @param {String} action
 * @param {String} description
 * @param {String} result
 * @param {String} admindesc
 * @returns {undefined}
 */
function saveActionUser(action, description, result, admindesc) {
    if (admindesc === undefined) {
        admindesc = "unknow";
    }

    var params = {
        action: action,
        description: description,
        result: result,
        admindesc: admindesc
    };

    $.ajax({
        type: 'POST',
        url: "userActions",
        data: params,
        dataType: 'json',
        success: function (data, textStatus, jqXHR) {
            var jsonData = JSON.stringify(data);
            ddlog("Save action admin ok !" + jsonData);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("error: jqXHR: " + JSON.stringify(jqXHR) + " textStatus: " + textStatus + " errorThrown: " + errorThrown);
        }
    });
}

function get_browser_info() {
    var ua = navigator.userAgent, tem, M = ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
    if (/trident/i.test(M[1])) {
        tem = /\brv[ :]+(\d+)/g.exec(ua) || [];
        return {name: 'IE ', version: (tem[1] || '')};
    }
    if (M[1] === 'Chrome') {
        tem = ua.match(/\bOPR\/(\d+)/);
        if (tem !== null) {
            return {name: 'Opera', version: tem[1]};
        }
    }
    M = M[2] ? [M[1], M[2]] : [navigator.appName, navigator.appVersion, '-?'];
    if ((tem = ua.match(/version\/(\d+)/i)) !== null) {
        M.splice(1, 1, tem[1]);
    }
    return {
        name: M[0],
        version: M[1]
    };
}

function getColor(index) {
    switch (index) {
        case 0:
            return "#800000";
        case 1:
            return "#FF6384";
        case 2:
            return "#36A2EB";
        case 3:
            return "#FFCE56";
        case 4:
            return "#8B008B";
        case 5:
            return "#00008B";
        case 6:
            return "#00008B";
        case 7:
            return "#D2691E";
        case 8:
            return "#008000";
        case 9:
            return "#4B0082";
        case 10:
            return "#20B2AA";
    }
    return "#fff";
}

function getValueKey(array, key) {
    for (var i = 0; i < array.length; ++i) {
        if (array[i].name === key) {
            return array[i].value;
        }
    }
    return "";
}

function validateBetweenDateString(dateFrom, dateTo) {
    var date = dateFrom.substring(0, 2);
    var month = dateFrom.substring(3, 5);
    var year = dateFrom.substring(6, 10);

    var date_from = new Date(year, month - 1, date);

    var date2 = dateTo.substring(0, 2);
    var monthTo = dateTo.substring(3, 5);
    var yearTo = dateTo.substring(6, 10);

    var date_to = new Date(yearTo, monthTo - 1, date2);

    return (date_from > date_to);
}

function uuidv4() {
  return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
    var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
    return v.toString(16);
  });
}

function getState() {
    
}