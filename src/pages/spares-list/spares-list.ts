import { Observable } from 'rxjs';
import { SpareServiceProvider } from './../../providers/spare-service/spare-service';
import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';
import { map } from 'rxjs/operators';

@Component({
  selector: 'page-spares-list',
  templateUrl: 'spares-list.html',
})
export class SparesListPage {

  items: Observable<any[]>;

  constructor(public navCtrl: NavController, public service: SpareServiceProvider) {
    this.items = this.service.getSpareList().snapshotChanges().pipe(map(changes => changes.map(c => ({ key: c.payload.key, ...c.payload.val() }))));
  }



}
