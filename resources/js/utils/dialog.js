export default {

    confirmDialog(content, btnOkTitle, fn) {
        BootstrapDialog.show({
            title: "Thông báo",
            type: BootstrapDialog.TYPE_DEFAULT,
            size: BootstrapDialog.SIZE_SMALL,
            message: content,
            buttons: [
                {
                    label: 'Đóng',
                    action: (dialog) => {
                        dialog.close();
                    }
                },
                {
                    label: btnOkTitle,
                    cssClass: 'btn-primary',
                    action: (dialog) => {
                        dialog.close();
                        if (typeof fn === "function") {
                            fn();
                        }
                    }
                }
            ]
        });
    },

    confirmDialogWithTitle(title,content, btnOkTitle, fn) {
        BootstrapDialog.show({
            title: title || "Thông báo",
            type: BootstrapDialog.TYPE_DEFAULT,
            size: BootstrapDialog.SIZE_SMALL,
            message: content,
            buttons: [
                {
                    label: 'Đóng',
                    action: (dialog) => {
                        dialog.close();
                    }
                },
                {
                    label: btnOkTitle,
                    cssClass: 'btn-primary',
                    action: (dialog) => {
                        dialog.close();
                        if (typeof fn === "function") {
                            fn();
                        }
                    }
                }
            ]
        });
    },

    showDialog(title, content, data, fnOnHide, size) {
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
                    action: (dialog) => {
                        dialog.close();
                    }
                }
            ],
            onhide: (dialogRef) => {
                if (typeof fnOnHide === "function") {
                    var rc = 0;
                    if (data !== null && data !== undefined) {
                        rc = dialogRef.getData("rc");
                    }
                    fnOnHide(rc);
                }
            }
        });
    },
}