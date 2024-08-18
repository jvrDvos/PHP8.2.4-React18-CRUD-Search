import axios from 'axios';

const instance = axios.create({
  baseURL: 'http://localhost/PHPReact.js18CRUDSearch/Api/'
});

export default instance;