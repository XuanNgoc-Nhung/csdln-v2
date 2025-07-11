import axios from 'axios';
import m_util from './m_utils';
import utils from './../utils';
import LZString from 'lz-string';
const randomString = (length) => {
    return Math.random().toString(36).substring(2, 2 + length);
};
export default {
    DEFAULT_TIME_OUT: 60000,
    create_params(method, path, params) {
        return {
            "path": path,
            "method": "POST",
            "data": params
        };
    },

    post(url, params, fn, tm, loading) {
        if (tm === undefined || tm === null) {
            tm = this.DEFAULT_TIME_OUT;
        }
        // console.log("POST " + url);
        // console.log("req = " + JSON.stringify(params));
        let data = {
            "path": url,
            "method": "POST",
            "data": params
        };
        this._request(data, fn, tm, loading);
    },

    get(url, params, fn, tm, loading) {
        if (tm === undefined || tm === null) {
            tm = this.DEFAULT_TIME_OUT;
        }
        // console.log("GET " + url);
        // console.log("req = " + JSON.stringify(params));
        let data = {
            "path": url,
            "method": "GET",
            "data": params
        };
        this._request(data, fn, tm, loading);
    },

    post2(url, params, fn, tm, loading) {
        if (tm === undefined || tm === null) {
            tm = this.DEFAULT_TIME_OUT;
        }
        // console.log("POST " + url);
        // console.log("req = " + JSON.stringify(params));
        let data = {
            "path": url,
            "method": "POST",
            "data": params
        };
        this._request2(data, fn, tm, loading);
    },

    get2(url, params, fn, tm, loading) {
        if (tm === undefined || tm === null) {
            tm = this.DEFAULT_TIME_OUT;
        }
        // console.log("GET " + url);
        // console.log("req = " + JSON.stringify(params));
        let data = {
            "path": url,
            "method": "GET",
            "data": params
        };
        this._request2(data, fn, tm, loading);
    },

    put(url, params, fn, tm, loading) {
        if (tm === undefined || tm === null) {
            tm = this.DEFAULT_TIME_OUT;
        }
        // console.log("PUT " + url);
        // console.log("req = " + JSON.stringify(params));
        let data = {
            "path": url,
            "method": "PUT",
            "data": params
        };
        this._request(data, fn, tm, loading);
    },
    delete(url, params, fn, tm, loading) {
        if (tm === undefined || tm === null) {
            tm = this.DEFAULT_TIME_OUT;
        }
        // console.log("DELETE " + url);
        // console.log("req = " + JSON.stringify(params));
        let data = {
            "path": url,
            "method": "DELETE",
            "data": params
        };
        this._request(data, fn, tm, loading);
    },



    _request(data, fn, tm, loading) {
        if (loading !== undefined && loading) {
            // m_util.showLoading(true);
        }
        let data_compressed = LZString.compressToBase64(JSON.stringify(data));
        data_compressed = randomString(10) + data_compressed;
        axios.post("forward-api", data_compressed, {timeout: tm}).then((response) => {
            // this.checkResponse(response);
            fn(response);
        }).catch((error) => {
            console.log(error);
            // alert('Hết phiên làm việc. Vui lòng thử lại!')
        }).then(function () {
            if (loading !== undefined && loading) {
                // m_util.hideAllModal();
            }
        });
    },

    _request2(data, fn, tm, loading) {
        if (loading !== undefined && loading) {
            // m_util.showLoading(true);
        }
        axios.post("forward-api-2", data, {timeout: tm}).then((response) => {
            // this.checkResponse(response);
            fn(response);
        }).catch((error) => {
            console.log(error);
            // alert('Hết phiên làm việc. Vui lòng thử lại!')
        }).then(function () {
            if (loading !== undefined && loading) {
                // m_util.hideAllModal();
            }
        });
    },

    async getAsync(url, params, tm, loading) {
        if (tm === undefined || tm === null) {
            tm = this.DEFAULT_TIME_OUT;
        }
        let data = {
            "path": url,
            "method": "GET",
            "data": params
        };
        // m_util.showLoading(true);
        const result = await axios.post("forward-api", data, {timeout: tm});
        if(result){
            if (loading !== undefined && loading) {
                // m_util.hideAllModal();
            }
            return result;
        }
        if (loading !== undefined && loading) {
            // m_util.hideAllModal();
        }
        return null;
    },
    checkResponse(response) {
        // m_util.hideAllModal();
        if (response !== null && response !== undefined && response.data !== null && response.data !== undefined) {
            const code = response.data.rc;
            if (code !== null && code !== undefined && !isNaN(code) && (code === 401 || code === 409 || code === 19)) {
                let uri = this.getBaseUrl();
                uri = uri.substring(0, uri.length - 1);
                uri += "logout";
                // window.location.replace(uri);
            }
        }
    },

    getBaseUrl() {
        let content = document.querySelector("meta[property='base-url']");
        let ret = "";
        if (content !== null && content !== undefined) {
            ret = content.getAttribute("content");
        }
        if (ret === null || ret === undefined) {
            ret = "";
        }
        return ret;
    }

}
