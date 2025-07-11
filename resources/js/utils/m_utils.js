import array_utils from './array_utils';

export default {

    isNumber(num) {
        return (num !== null && num !== undefined && !isNaN(num));
    },

    checkString(str) {
        if (str === undefined || str === null) {
            return false;
        }
        if (typeof str === 'string' || str instanceof String) {
            return str.trim() !== "";
        }
        return !isNaN(str);
    },

    checkUserName(username) {
        if (!this.checkString(username)) {
            return false;
        }
        if (username.trim().length < 6) {
            return false;
        }
        return true;
    },

    checkPhoneNumber(phone) {
        if (!this.checkString(phone)) {
            return false;
        }
        let flag = false;
        phone = phone.replace('(+84)', '0');
        phone = phone.replace('+84', '0');
        phone = phone.replace('0084', '0');
        phone = phone.replace(/ /g, '');
        if (phone !== '') {
            var firstNumber = phone.substring(0, 2);
            if ((parseInt(firstNumber) < 10 && parseInt(firstNumber) > 0) && phone.length === 10) {
                if (phone.match(/^\d{10}/)) {
                    flag = true;
                }
            } else if (firstNumber === '01' && phone.length === 11) {
                if (phone.match(/^\d{11}/)) {
                    flag = true;
                }
            }
        }
        return flag;
    },

    checkIp(ipaddress) {
        if (/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(ipaddress)) {
            return true;
        }
        return false;
    },

    checkData(data) {
        return (data !== undefined && data !== null);
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

    getLowerString(str) {
        if (str === undefined || str === null) {
            return "";
        }
        return str.trim().toLowerCase();
    },

    arrayToString(arr, delim) {
        if (!array_utils.isArray(arr)) {
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

    id: function () {
        return '_' + Math.random().toString(36).substr(2, 9);
    },

    hideAllModal() {
        $("#mdLoading").modal("hide");
        $('.modal-backdrop').remove();
    },

    showLoading(state) {
        this.hideAllModal();
        if (state === undefined || state === null) {
            state = false;
        }
        if (state) {
            $("#mdLoading").modal('show');
        } else {
            $("#mdLoading").modal("hide");
        }
    },

    getMessageResponse(res, success, failure) {
        if (res === undefined || res === null || res.data === undefined || res.data === null) {
            return "<b>" + failure + "</b>";
        }
        if (res.data.rc === undefined || res.data.rc === null) {
            return "<b>" + failure + "</b>";
        }
        if (parseInt(res.data.rc) === 0) {
            return "<b>" + success + "</b>";
        }
        if (!this.checkString(res.data.rd)) {
            return "<b>" + failure + "</b>";
        }
        return "<b>" + res.data.rd + "</b>";
    },

}