import { AngularFireDatabase } from 'angularfire2/database';
import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable()
export class SpareServiceProvider {
  private spareListRef = this.db.list<any>('spares');

  constructor(private db: AngularFireDatabase) {
    console.log('Hello SpareServiceProvider Provider');



  }


  getSpareList() {
    return this.spareListRef;

  }

  addSpare(spare: any) {
    return this.spareListRef.push(spare);
  }

  updateSpare(spare: any) {
    return this.spareListRef.update(spare.key, spare);
  }

  removeSpare(spare: any) {
    return this.spareListRef.remove(spare.key);
  }

}
