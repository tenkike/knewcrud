import { Component } from '@angular/core';
import { DataService } from './config/config.service';
//import { Observable } from 'rxjs';

@Component({
  //title: 'welcome app',
  selector: 'app-root',
  templateUrl: './app.component.html'

})

export class AppComponent {

  dataMenu: any;

  constructor(private dataService: DataService) { }

  ngOnInit(): void {
    this.dataService.ngOnInit().subscribe((response) => {

      this.dataMenu = JSON.stringify(response);
  
      console.log('object', this.dataMenu);
      


    });
  }
}








