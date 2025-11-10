export default function globalPopup() {
    return {
        visible: false,
        type: 'info',
        title: '',
        message: '',

        show(type, title, message) {
            this.type = type
            this.title = title
            this.message = message
            this.visible = true

            //setTimeout(() => this.visible = false, 3000)
        }
    }
}