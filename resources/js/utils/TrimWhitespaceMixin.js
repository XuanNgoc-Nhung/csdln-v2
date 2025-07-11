// TrimWhitespaceMixin.js
export default {
    methods: {
      trimValue(value) {
        console.log('trimValue');
        console.log(value);
        let vl=  value.trim();
        console.log(vl);
        return vl;
      },
    },
  };