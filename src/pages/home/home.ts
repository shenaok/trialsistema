import { Component, ViewChild  } from '@angular/core';
import { NavController } from 'ionic-angular';
import { Http } from '@angular/http';
import { LoginPage } from '../login/login';
import { AddnewemployeePage } from '../addnewemployee/addnewemployee'


@Component({
  templateUrl: 'home.html'
})
export class HomePage {
  public items: any=[];
  @ViewChild(AddnewemployeePage) AddnewemployeePage: AddnewemployeePage;

  // rootPage = HomePage;
  
  constructor(public navCtrl: NavController, public http: Http) { }

  ionViewWillEnter()
   {
     //hai
      this.load();
   }

   // Retrieve the JSON encoded data from the remote server
   // Using Angular 2's Http class and an Observable - then
   // assign this to the items array for rendering to the HTML template
   logout()
   {
      this.navCtrl.setRoot(LoginPage);
   }

   load()
   {
      this.http.get('http://localhost/trialsistemaAPI/RetrieveEmployeeData.php')
      .map(res => res.json())
      .subscribe(data =>
      {
         this.items = data;
      });
   }

     // Allow navigation to the AddTechnologyPage for creating a new entry
   addNewEmployee()
   {
      this.navCtrl.push(AddnewemployeePage);
   }

   editEmployee(item:any)
   {
     this.navCtrl.push(AddnewemployeePage,{isEditMode:true,selectedEmployee:item});
   }


   // Allow navigation to the AddTechnologyPage for amending an existing entry
   // (We supply the actual record to be amended, as this method's parameter,
   // to the AddTechnologyPage
   viewEntry(param)
   {
      //this.navCtrl.push(AddTechnologyPage, param);
   }

}



