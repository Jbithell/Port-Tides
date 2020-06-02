import React from 'react';
import { PDF } from '../models/PDF';
import { IonCard, IonCardHeader, IonItem, IonLabel, IonCardContent, IonList } from '@ionic/react';


interface PDFItemProps {
  pdf: PDF;
}

export const PDFItemComponent: React.FC<PDFItemProps> = ({ pdf }) => {
  function openExternalUrl(url: string) {
    window.open(url, '_blank');
  }

  return (
    <>
      <IonCard className="speaker-card">
        <IonCardHeader>
          <IonItem button detail={false} lines="none" className="speaker-item" onClick={() => openExternalUrl(`${pdf.url}`)}>
            <IonLabel>
              <h2>{pdf.name}</h2>
            </IonLabel>
          </IonItem>
        </IonCardHeader>
      </IonCard>
    </>
  );
};

