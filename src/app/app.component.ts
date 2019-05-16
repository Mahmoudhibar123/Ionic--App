import { AddSparePage } from './../pages/add-spare/add-spare';
import { ContactPage } from './../pages/contact/contact';
import { User } from './../models/user';
import { LogoutPage } from './../pages/logout/logout';
import { SparesListPage } from './../pages/spares-list/spares-list';
import { RegisterPage } from './../pages/register/register';
import { LoginPage } from './../pages/login/login';
import { Component, ViewChild } from '@angular/core';
import { Nav, Platform, Events } from 'ionic-angular';
import { StatusBar } from '@ionic-native/status-bar';
import { SplashScreen } from '@ionic-native/splash-screen';

import { HomePage } from '../pages/home/home';
import { ListPage } from '../pages/list/list';


@Component({
  templateUrl: 'app.html'
})
export class MyApp {
  @ViewChild(Nav) nav: Nav;
  user = {} as User;
  rootPage: any = AddSparePage;

  pages: Array<{title: string, component: any}>;

  constructor( events: Events ,public platform: Platform, public statusBar: StatusBar, public splashScreen: SplashScreen) {
    this.initializeApp();

    // used for an example of ngFor and navigation
    this.pages = [
      { title: 'Home', component: HomePage },
      { title: 'Login', component: LoginPage },
      { title: 'Registration', component: RegisterPage },
      { title: 'Contact Us', component: ContactPage }


    ];

    events.subscribe('user:loggedin', () => {
      this.pages = [
        { title: 'SparesList', component: SparesListPage },
        { title: 'Logout', component: LogoutPage },
        { title: 'List' , component: ListPage}





      ];
    });


  }

  initializeApp() {
    this.platform.ready().then(() => {
      // Okay, so the platform is ready and our plugins are available.
      // Here you can do any higher level native things you might need.
      this.statusBar.styleDefault();
      this.splashScreen.hide();
    });
  }

  openPage(page) {
    // Reset the content nav to have just this page
    // we wouldn't want the back button to show in this scenario
    this.nav.setRoot(page.component);
  }
}
