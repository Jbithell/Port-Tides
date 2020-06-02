import React, { useState } from 'react';
import {
  IonHeader,
  IonToolbar,
  IonContent,
  IonPage,
  IonButtons,
  IonMenuButton,
  IonList,
  IonItem,
  IonLabel,
  IonTitle
} from '@ionic/react';
import './About.scss';

interface AboutProps { }

const About: React.FC<AboutProps> = () => {
  return (
    <IonPage id="about-page">
      <IonContent>
        <IonHeader className="ion-no-border">
          <IonToolbar>
            <IonButtons slot="start">
              <IonMenuButton />
            </IonButtons>
            <IonTitle></IonTitle>
          </IonToolbar>
        </IonHeader>
        <div className="about-header">
          <div className="about-image"></div>
        </div>
        <div className="about-info">
          <h3 className="ion-padding-top ion-padding-start">About</h3>
          <p className="ion-padding-start ion-padding-end">This site & app displays free tidal predictions for the seaside town of Porthmadog and its beautiful estuary</p>

          <h3 className="ion-padding-top ion-padding-start">Timezone</h3>
          <IonList lines="none">
            <IonItem>
              <IonLabel>
                Tidal Predictions
              </IonLabel>
              Displayed in GMT/BST
            </IonItem>
          </IonList>

          <h3 className="ion-padding-top ion-padding-start">Copyright Information</h3>
          <IonList lines="none">
            <IonItem>
              All Tidal Data is ©Crown Copyright. Reproduced by permission of the Controller of Her Majesty's Stationery Office and the UK Hydrographic Office (www.ukho.gov.uk). No tidal data may be reproduced without the expressed permission of the ukho licencing department.
            </IonItem>
            <IonItem>
              <IonLabel>
                PDFs, Website & App
              </IonLabel>
              ©2014-2020 James Bithell
            </IonItem>
          </IonList>

          <h3 className="ion-padding-top ion-padding-start">Disclaimer</h3>

          <p className="ion-padding-start ion-padding-end">Tidal Predictions are provided for use by all water users though the developers of this site can not be held accountable for the accuracy of this data or any accidents that result from the use of this data.</p>


        </div>
      </IonContent>

    </IonPage>
  );
};

export default React.memo(About);
