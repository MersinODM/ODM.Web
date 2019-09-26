export default {
  getBasePath () {
    let getUrl = window.location
    return `${getUrl.protocol}//${getUrl.host}/${getUrl.pathname.split('/')[1]}`
  }
}
