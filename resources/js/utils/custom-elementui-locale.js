import vi from 'element-ui/lib/locale/lang/vi';
export default {
    ...vi,
    el: {
        ...vi.el,
        datepicker: {
            ...vi.el.datepicker,
            year: '', // Example: Custom "no data" text
        },

    },
};