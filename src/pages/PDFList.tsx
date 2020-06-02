import React from 'react';
import { IonHeader, IonToolbar, IonTitle, IonContent, IonPage, IonButtons, IonMenuButton, IonGrid, IonRow, IonCol } from '@ionic/react';
import { PDF } from '../models/PDF';
import { PDFItemComponent } from '../components/PDFItem';
import { connect } from '../data/connect';
import * as selectors from '../data/selectors';
import './PDFList.scss';

interface OwnProps { };

interface StateProps {
  pdfs: PDF[];
};

interface DispatchProps { };

interface PDFListProps extends OwnProps, StateProps, DispatchProps { };

const PDFList: React.FC<PDFListProps> = ({ pdfs }) => {

  return (
    <IonPage id="speaker-list">
      <IonHeader translucent={true}>
        <IonToolbar>
          <IonButtons slot="start">
            <IonMenuButton />
          </IonButtons>
          <IonTitle>PDFs</IonTitle>
        </IonToolbar>
      </IonHeader>

      <IonContent fullscreen={true}>
        <IonHeader collapse="condense">
          <IonToolbar>
            <IonTitle size="large">PDFs</IonTitle>
          </IonToolbar>
        </IonHeader>

          <IonGrid fixed>
            <IonRow>
              {pdfs.map(pdf => Date.parse(pdf.date) < (Date.now()+(1000*60*60*24*365)) ? (
                <IonCol size="12" size-md="6">
                  <PDFItemComponent
                    pdf={pdf}
                  />
                </IonCol>
              ) : '')}
            </IonRow>
          </IonGrid>
      </IonContent>
    </IonPage>
  );
};

export default connect<OwnProps, StateProps, DispatchProps>({
  mapStateToProps: (state) => ({
    pdfs: selectors.getPDFs(state)
  }),
  component: React.memo(PDFList)
});
