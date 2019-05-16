import { NgModule } from '@angular/core';
import { IonicPageModule } from 'ionic-angular';
import { SparesListPage } from './spares-list';

@NgModule({
  declarations: [
    SparesListPage,
  ],
  imports: [
    IonicPageModule.forChild(SparesListPage),
  ],
})
export class SparesListPageModule {}
