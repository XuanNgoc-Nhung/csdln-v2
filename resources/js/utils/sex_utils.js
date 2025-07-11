import m_utils from './m_utils';

export default {

    getGender(strGender) {
        if (!m_utils.checkString(strGender)) {
            return strGender;
        }
        let res = strGender.toLowerCase();
        if (res === 'nam' || res === 'male') {
            return "Nam";
        }
        if (res === 'nu' || res === 'female' || res === "nữ") {
            return "Nữ";
        }
        return strGender;
    }

}