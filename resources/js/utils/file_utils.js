export default {

    isFile(file) {
        if (file === null || file === undefined) {
            return false;
        }
        return Object.prototype.toString.call(file) === '[object File]';
    },

    checkImage(file) {
        let fileType = file["type"];
        let valids = ["image/gif", "image/jpeg", "image/png"];
        if ($.inArray(fileType, valids) < 0) {
            return false;
        }
        return true;
    },

    getFileSize(file) {
        return file.size;
    },

    readImage(file, func) {
        let fr = new FileReader();
        fr.onload = function (e) {
            func(fr.result);
        };
        fr.readAsDataURL(file);
    }
}