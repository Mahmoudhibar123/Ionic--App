import { HomePage } from './../home/home';
import { AngularFireAuth } from 'angularfire2/auth';
import { SparesListPage } from './../spares-list/spares-list';
import { Events } from 'ionic-angular';

import { User } from './../../models/user';
import { RegisterPage } from './../register/register';
import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';




@IonicPage()
@Component({
  selector: 'page-login',
  templateUrl: 'login.html',
})
export class LoginPage {
form:FormGroup;
  user = {} as User;

  constructor( private afAuth: AngularFireAuth, public navCtrl: NavController, public navParams: NavParams, private formBuilder: FormBuilder, public events:Events) {
  this.form=this.formBuilder.group({

      email: [
       "", Validators.compose([Validators.required,
      Validators.pattern('^[a-z0-9_+-]+@[a-z0-9.-]+\.[com]{2,4}$')])
      ],
      password: [
       "", Validators.compose([Validators.required,Validators.minLength(8)])
      ]
  });


  }


  async login(user: User) {
    try {
     const result =  this.afAuth.auth.signInWithEmailAndPassword(user.email, user.password)
      if (result) {
        //on success

        this.navCtrl.setRoot(SparesListPage);
      }
    }
    catch (e) {
      console.error(e);
    }
}


  register(){
    this.navCtrl.push(RegisterPage);
  }


}
