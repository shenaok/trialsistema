import { Component, ViewChild  } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';
import { Http, Headers } from "@angular/http";
import { HomePage } from '../home/home';
import { AlertController } from 'ionic-angular';

/*
  Generated class for the Login page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/

@Component({
  selector: 'page-login',
  templateUrl: 'login.html'
})
export class LoginPage {
  data : any;
  
  constructor(public navCtrl: NavController,public navParams: NavParams, private http:Http,public alertCtrl: AlertController) {
    this.data  ={};
    this.data.username = "";
    this.data.password = "";
  }

  login(){
    let username = this.data.username;
    let password = this.data.password;
    let datajson = JSON.stringify({username,password});
    let link = "http://localhost/trialsistemaAPI/LoginAPI.php";

    this.http.post(link,datajson)
      .map(res => res.json())
      .subscribe(result=>{
        {
          if(result == 1)
          {
            this.showAlert();
            this.navCtrl.setRoot(HomePage);
          }
          else{
            this.showErrorAlert();
          }
        }
      },error=>{
        console.log("error");
      });
  }

  showAlert() {
    let alert = this.alertCtrl.create({
      title: 'WELCOME!',
      subTitle: 'Welcome ' + this.data.username + " !",
      buttons: ['OK']
    });
    alert.present();
  }

  showErrorAlert() {
    let alert = this.alertCtrl.create({
      title: 'Login Failed!',
      subTitle: 'Login Failed. Please try again.',
      buttons: ['OK']
    });
    alert.present();
  }
}
