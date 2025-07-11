export default {

    getCommonDatas() {
        let content = document.querySelector("meta[property='aps-token']");
        let ret = "";
        if (content !== null && content !== undefined) {
            ret = content.getAttribute("content");
        }
        if (ret === undefined) {
            ret = "";
        }
        return ret;
    },

    decryptCommonDatas() {
        let datas = this.getCommonDatas();
        datas = this.decrypt(datas);
        return JSON.parse(datas);
    },

    decrypt(data) {
        return data;
    },

    encrypt(data) {
        return data;
    }

}