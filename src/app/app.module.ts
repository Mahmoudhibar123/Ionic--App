import { AddSparePageModule } from './../pages/add-spare/add-spare.module';
import { ContactPage } from './../pages/contact/contact';
import { SparesListPageModule } from './../pages/spares-list/spares-list.module';
import { RegisterPageModule } from './../pages/register/register.module';
import { LoginPageModule } from './../pages/login/login.module';
//import { RegisterPage } from './../pages/register/register';
//import { LoginPage } from './../pages/login/login';
import { BrowserModule } from '@angular/platform-browser';
import { ErrorHandler, NgModule } from '@angular/core';
import { IonicApp, IonicErrorHandler, IonicModule } from 'ionic-angular';
import { SparesListPage } from './../pages/spares-list/spares-list';
import { MyApp } from './app.component';
import { HomePage } from '../pages/home/home';
import { ListPage } from '../pages/list/list';
import { StatusBar } from '@ionic-native/status-bar';
import { SplashScreen } from '@ionic-native/splash-screen';
import { AngularFireModule } from 'angularfire2';
import { AngularFireAuthModule } from 'angularfire2/auth';
import { AngularFireAuth } from 'angularfire2/auth';
import { AngularFireDatabase } from 'angularfire2/database';
import { ContactPageModule } from '../pages/contact/contact.module';
import { CartProvider } from '../providers/cart/cart';
import { from } from 'rxjs/observable/from';
import { SpareServiceProvider } from '../providers/spare-service/spare-service';


const FIREBASE_INFO = {
apiKey: "AIzaSyCowaCaCsaEX5btDpi7vbQV9yF29lhJ2SA",
authDomain: "ionicapp-a9c21.firebaseapp.com",
databaseURL: "https://ionicapp-a9c21.firebaseio.com",
projectId: "ionicapp-a9c21",
storageBucket: "ionicapp-a9c21.appspot.com",
messagingSenderId: "221301444336"
}

@NgModule({
  declarations: [
    MyApp,
    HomePage,
    ListPage


  ],
  imports: [
    BrowserModule,
    IonicModule.forRoot(MyApp),
    LoginPageModule,
    RegisterPageModule,
    SparesListPageModule,
    AngularFireModule.initializeApp(FIREBASE_INFO),
    AngularFireAuthModule,
    ContactPageModule
      ],
  bootstrap: [IonicApp],
  entryComponents: [
    MyApp,
    HomePage,
    ListPage



  ],
  providers: [
    StatusBar,
    SplashScreen,
    { provide: ErrorHandler, useClass: IonicErrorHandler },
    AngularFireDatabase,
    CartProvider,
    SpareServiceProvider
  ]
})
export class AppModule {}
