import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class setServices {

  menuData: any;

  constructor() { }

  setMenuData(data: any): void {
    this.menuData = data;
  }

}