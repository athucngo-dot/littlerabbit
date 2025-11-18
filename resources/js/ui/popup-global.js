export default function globalPopup() {
    return {
        visible: false,
        type: 'info',
        title: '',
        message: '',
        confirmCallback: null,

        show(type, title, message) {
            this.type = type
            this.title = title
            this.message = message
            this.visible = true

            /*if (type !== 'confirm') {
                setTimeout(() => this.visible = false, 3000);
            }*/
        },

        confirm(title, message, callback) {
            this.type = 'confirm';
            this.title = title;
            this.message = message;
            this.confirmCallback = callback;
            this.visible = true;
        }
    }
}