import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { HttpClientModule, HTTP_INTERCEPTORS } from '@angular/common/http';
//import { HttpXsrfInterceptor } from '@angular/common/http';
import {XsrfInterceptor} from './config/interceptors';
import { AppComponent } from './app.component';

@NgModule({
  declarations: [
    AppComponent
  ],
  imports: [
    BrowserModule,
    HttpClientModule
  ],
  providers: [
      
     { provide: HTTP_INTERCEPTORS, useClass: XsrfInterceptor, multi: true },
     //{ provide: HTTP_INTERCEPTORS, useClass: HttpInterceptor, multi: true }	
  
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
