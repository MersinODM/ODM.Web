export default {
  getBasePath () {
    const getUrl = window.location
    return `${getUrl.protocol}//${getUrl.host}/${getUrl.pathname.split('/')[1]}`
  }
}
