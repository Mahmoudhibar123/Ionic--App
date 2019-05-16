import { SparesListPage } from './../spares-list/spares-list';
import { SpareServiceProvider } from './../../providers/spare-service/spare-service';
import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';

@IonicPage()
@Component({
  selector: 'page-add-spare',
  templateUrl: 'add-spare.html',
})
export class AddSparePage {
  spare = {};
  constructor(public navCtrl: NavController, public navParams: NavParams, private service: SpareServiceProvider) {



  }

  ionViewDidLoad() {
    console.log('ionViewDidLoad AddSparePage');
  }

  addSpare(spare) {
    this.service.addSpare(spare);
    this.navCtrl.push(SparesListPage);
  }

}
