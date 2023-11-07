import axios from 'axios'
import _ from 'lodash'
window._ = _

axios.defaults.withCredentials = true
axios.defaults.baseURL = 'http://localhost:8000/api'

window.axios = axios

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
