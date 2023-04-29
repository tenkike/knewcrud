import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { HttpXsrfTokenExtractor } from '@angular/common/http';
//import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class DataService {
    private apiUrl = 'http://knewsweb.org/api/menu';	

  constructor(
  	private http: HttpClient,
  	private tokenExtractor: HttpXsrfTokenExtractor
  	) { }
  
    ngOnInit() {
  
    const token = this.tokenExtractor.getToken();
    const headers = new HttpHeaders()
    .set('Content-Type', 'application/json; charset=utf-8')
    //.set('X-XSRF-TOKEN', token);
      
      return this.http.get(this.apiUrl, {headers});
  }
}

