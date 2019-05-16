import { SparesListPage } from './../spares-list/spares-list';
import { SpareServiceProvider } from './../../providers/spare-service/spare-service';
import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';
import { Spare } from '../../models/spare';


@IonicPage()
@Component({
  selector: 'page-edit-spare',
  templateUrl: 'edit-spare.html',
})
export class EditSparePage {
  spare = {};
  constructor(private service: SpareServiceProvider,public navCtrl: NavController, public navParams: NavParams) {
  }

  ionViewDidLoad() {
    console.log('ionViewDidLoad EditSparePage');
    this.spare = this.navParams.get('spare');
  }

  updateSpare(spare) {
    this.service.updateSpare(spare);
    this.navCtrl.push(SparesListPage);
  }

  removeSpare(spare) {
    this.service.removeSpare(spare);
    this.navCtrl.push(SparesListPage);
  }
}
