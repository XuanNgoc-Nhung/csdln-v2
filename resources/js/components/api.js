import axios from 'axios';

export default {
    DEFAULT_TIME_OUT: 60000,
    get(url, params, fn, tm, loading = false) {
        if (tm === undefined || tm === null) {
            tm = 60000;
        }
        if(loading){
            showLoading(true);
        }
        axios.get(url, {
            params: params,
            timeout: tm
        }).then((response) => {
            this.checkResponse(response);
            fn(response);
            hideAllModal();
        }).catch((error) => {
            console.log(error);
        }).catch(() => hideAllModal());
    },
    post(url, params, fn, tm) {
        if (tm === undefined || tm === null) {
            tm = 60000;
        }
        axios.post(url, params, {timeout: tm}).then((response) => {
            // axios.post(url, params).then((response) => {
            this.checkResponse(response);
            fn(response);
        }).catch((error) => {
            console.log(error);
        });
    },
    postForm(url, formData, fn) {
        axios.post(url, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }).then((response) => {
            this.checkResponse(response);
            fn(response);
            console.log(response);
        }).catch((error) => {
            console.log(error);
        });
    },
    checkResponse(response) {
        if (response !== null && response !== undefined && response.data !== null && response.data !== undefined) {
            const code = response.data.code;
            if (code !== null && code !== undefined && !isNaN(code) && (code === 401 || code === 409)) {
                let uri = this.getBaseUrl();
                uri += "/login";
                window.location.replace(uri);
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
