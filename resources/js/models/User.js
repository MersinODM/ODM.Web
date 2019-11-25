import jwtDecode from 'jwt-decode'

export default class JwtUser {
  id = 0;
  instId = 0;
  fullName = '';
  role=null;
  email = '';
  userName = '';
  expirationDate = null;
  issuedDate = null;

  constructor (accessToken) {
    const decodedToken = jwtDecode(accessToken)
    this.id = decodedToken.sub
    this.instId = decodedToken.instId
    this.fullName = decodedToken.name
    this.role = decodedToken.role
    this.email = decodedToken.email
    this.userName = decodedToken.code
    this.expirationDate = new Date(decodedToken.exp)
    this.issuedDate = new Date(decodedToken.iat)
  }
}
