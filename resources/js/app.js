import './bootstrap'

import Alpine from 'alpinejs'
window.Alpine = Alpine

import dashboardAddress from './dashboard_address.js';
window.loadDashboardAddress = dashboardAddress;

import cart from './cart.js';
window.loadCart = cart;

import globalPopup from './ui/popup-global.js'

// Register only if globalPopup exists
document.addEventListener('alpine:init', () => {
    Alpine.data('globalPopup', globalPopup)
})

window.popup = {
    success(message, title = "Success") {
        dispatch('success', title, message)
    },
    error(message, title = "Error") {
        dispatch('error', title, message)
    },
    info(message, title = "Info") {
        dispatch('info', title, message)
    },
    confirm(title, message, callback) {
        window.dispatchEvent(new CustomEvent('popup:confirm', {
            detail: { title, message, callback }
        }));
    }
}

function dispatch(type, title, message) {
    window.dispatchEvent(new CustomEvent('popup:show', {
        detail: { type, title, message }
    }))
}

// call Alpine
Alpine.start()

// Listen only when popup component exists
window.addEventListener('popup:show', e => {
    const el = document.querySelector('[x-data*=globalPopup]')
    if (!el?._x_dataStack) return

    el._x_dataStack[0].show(
        e.detail.type,
        e.detail.title,
        e.detail.message
    )
})

window.addEventListener('popup:confirm', e => {
    const el = document.querySelector('[x-data*=globalPopup]')
    if (!el?._x_dataStack) return

    el._x_dataStack[0].confirm(
        e.detail.title,
        e.detail.message,
        e.detail.callback
    )
})