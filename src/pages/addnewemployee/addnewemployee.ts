import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';
import { Http, Headers, RequestOptions  } from '@angular/http';
import { AlertController } from 'ionic-angular';

/*
  Generated class for the Addnewemployee page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  selector: 'page-addnewemployee',
  templateUrl: 'addnewemployee.html'
})
export class AddnewemployeePage {
private baseURI 		: string  = "http://localhost/trialsistemaAPI/";
newEmployeeData : any;
private EditMode : boolean;
private PageTitle : string; 

  constructor(
      public navCtrl: NavController, 
      public navParams: NavParams, 
      public http: Http, 
      public alertCtrl: AlertController) 
      {
        this.EditMode = navParams.get("isEditMode");

        if(this.EditMode)
        {
          this.PageTitle = "Edit Employee";
          this.newEmployeeData = navParams.get("selectedEmployee");
        }else{
          this.PageTitle = "Add New Employee";
         
          this.newEmployeeData  ={};
          this.newEmployeeData.FirstName = "";
          this.newEmployeeData.LastName = "";
          this.newEmployeeData.Username = "";
          this.newEmployeeData.Password = "";
      }
}

  submitSave()
   {
     let type 	 : string	 = "application/x-www-form-urlencoded; charset=UTF-8",
            headers: any		 = new Headers({ 'Content-Type': type}),
            options: any 		 = new RequestOptions({ headers: headers }),
            url 	 : any		 = this.baseURI + "managedata.php",
            body : string;

     if(this.EditMode)
     {
        body = "key=update&FirstName=" + this.newEmployeeData.FirstName + "&LastName=" + this.newEmployeeData.LastName+ "&Username=" + this.newEmployeeData.Username+ "&Password=" + this.newEmployeeData.Password+ "&EmployeeID=" + this.newEmployeeData.EmployeeID;
     }else{
       body = "key=create&FirstName=" + this.newEmployeeData.FirstName + "&LastName=" + this.newEmployeeData.LastName+ "&Username=" + this.newEmployeeData.Username+ "&Password=" + this.newEmployeeData.Password;
     }

      this.http.post(url, body, options)
      .map(res => res.json())
      .subscribe((result) =>
      {
        // If the request was successful notify the user
        if(result == 1)
        {
          this.showAlert();

          if(!this.EditMode)
            this.resetfield();
        }
        else
        {
          this.showErrorAlert();
        }
      });
   }

  ionViewDidLoad() {
    console.log('ionViewDidLoad AddnewemployeePage');
  }

  showAlert() {
    let alert = this.alertCtrl.create({
      title: 'Save Success!',
      subTitle: this.EditMode? "Employee Edited." : this.newEmployeeData.FirstName + ' ' + this.newEmployeeData.LastName + ' saved.',
      buttons: ['OK']
    });
    alert.present();
  }

  showErrorAlert() {
    let alert = this.alertCtrl.create({
      title: 'Save Failed!',
      subTitle: this.EditMode? "Employee Edit Failed" : this.newEmployeeData.FirstName + ' ' + this.newEmployeeData.LastName + ' not saved.',
      buttons: ['OK']
    });
    alert.present();
  }

  resetfield(){
    this.newEmployeeData  ={};
  }
}
