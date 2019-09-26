export default {
  install (Vue, options) {
    // Base path bulma fplugin i
    Vue.prototype.$getBasePath = () => {
      if (!window.location.host.includes('localhost')) {
        return window.location.pathname.split('/').slice(0, -1).join('/')
      }
      return ''
    }
  }
}
