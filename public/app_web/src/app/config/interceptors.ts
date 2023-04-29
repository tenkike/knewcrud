import { Injectable } from '@angular/core';
import { HttpEvent, HttpInterceptor, HttpXsrfTokenExtractor, HttpHandler, HttpRequest } from '@angular/common/http';

@Injectable()
export class XsrfInterceptor implements HttpInterceptor {
  constructor(private tokenExtractor: HttpXsrfTokenExtractor) {}
  
  intercept(req: HttpRequest<any>, next: HttpHandler) {
      const headerName = 'X-XSRF-TOKEN';
    // obtener el token CSRF
    const token = this.tokenExtractor.getToken() as string;
    
    // clonar la solicitud y añadir el token CSRF al encabezado X-XSRF-TOKEN
        if (token !== null && !req.headers.has(headerName)) {
          req = req.clone({ headers: req.headers.set(headerName, token) });
    	}
    // enviar la solicitud modificada al siguiente interceptor o al servidor
    return next.handle(req);
  }
}

