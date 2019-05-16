import { NgModule } from '@angular/core';
import { IonicPageModule } from 'ionic-angular';
import { AddSparePage } from './add-spare';

@NgModule({
  declarations: [
    AddSparePage,
  ],
  imports: [
    IonicPageModule.forChild(AddSparePage),
  ],
})
export class AddSparePageModule {}
