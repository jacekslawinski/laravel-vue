import { VueInstance } from '@root/main';
import axios, { AxiosInstance, AxiosRequestConfig, AxiosResponse } from 'axios';
import { AppEvents } from './AppEvents';

export enum HttpStatuses {
  ok = 200,
  badRequest = 400,
  notFound = 404,
  validation = 422,
  serverError = 500
}

abstract class AbstractClient {
  protected axiosInstance: AxiosInstance;

  constructor(headers: any = {}) {
    this.axiosInstance = axios.create({
      baseURL: '',
      headers: Object.assign({
        'Content-Type': 'application/json'
      }, headers)
    });
    this.initializeResponseInterceptor();
  }

  protected get(url: string, config?: AxiosRequestConfig) {
    return this.axiosInstance
      .get(url, config)
      .then((response: AxiosResponse<any>) => response.data)
  }

  protected post(url: string, data: any, config?: AxiosRequestConfig) {
    return this.axiosInstance
      .post(url, data, config)
      .then((response: AxiosResponse) => response.data);
  }

  protected put(url: string, data: any, config?: AxiosRequestConfig) {
    return this.axiosInstance
      .put(url, data, config)
      .then((response: AxiosResponse) => response.data);
  }

  protected delete(url: string, config?: AxiosRequestConfig) {
    return this.axiosInstance
      .delete(url, config)
      .then((response: AxiosResponse) => response.data);
  }

  private initializeResponseInterceptor() {
    this.axiosInstance.interceptors.response.use(response => response, error => {
      const message = this.createMessage(error.response.status, error.response.config.method);
      VueInstance.$root.$emit(AppEvents.SHOW_ERROR, message)
      return Promise.reject(error);
    });
  }

  createMessage(responseStatus: number, requestMethod: string) {
    if (responseStatus === HttpStatuses.validation) {
      return VueInstance.$t('api.errors.validationErrors');
    }
    const messageResponse = VueInstance.$t('api.errors.status.' + (HttpStatuses[responseStatus] || 'unexpected'));
    const messageMethod = VueInstance.$t('api.errors.method.' + requestMethod);
    return `${messageMethod} (${messageResponse})`;
  }
}

export default AbstractClient
