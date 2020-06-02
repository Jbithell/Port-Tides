import React, { useState, useRef } from 'react';
import { IonContent, IonPage, IonHeader, IonToolbar, IonButtons, IonButton, IonSlides, IonSlide, IonIcon, useIonViewWillEnter } from '@ionic/react';
import { arrowForward } from 'ionicons/icons';
import { setHasSeenTutorial } from '../data/user/user.actions';
import './Tutorial.scss';
import { connect } from '../data/connect';
import { RouteComponentProps } from 'react-router';

interface OwnProps extends RouteComponentProps {};

interface DispatchProps {
  setHasSeenTutorial: typeof setHasSeenTutorial;
}

interface TutorialProps extends OwnProps, DispatchProps { };

const Tutorial: React.FC<TutorialProps> = ({ history, setHasSeenTutorial }) => {
  const [showSkip, setShowSkip] = useState(true);
  const slideRef = useRef<HTMLIonSlidesElement>(null);

  useIonViewWillEnter(() => {

  });

  const startApp = async () => {
    await setHasSeenTutorial(true);
    history.push('/tabs/schedule', { direction: 'none' });
  };

  const handleSlideChangeStart = () => {
    slideRef.current!.isEnd().then(isEnd => setShowSkip(!isEnd));
  };

  return (
    <IonPage id="tutorial-page">
      <IonHeader no-border>
        <IonToolbar>
          <IonButtons slot="end">
            {showSkip && <IonButton color='primary' onClick={startApp}>Skip</IonButton>}
          </IonButtons>
        </IonToolbar>
      </IonHeader>
      <IonContent fullscreen>

        <IonSlides ref={slideRef} onIonSlideWillChange={handleSlideChangeStart} pager={false}>
          <IonSlide>
            <h2 className="slide-title">
              Welcome to <b>Porthmadog Tide Times</b>
            </h2>
            <p>
              This app and website provides free tidal predictions for the next 12 months, with data provided by the United Kingdom Hydrographic Office
            </p>
          </IonSlide>

          <IonSlide>
            <h2 className="slide-title">Safety at Sea</h2>
            <p>
              <b>Follow advice</b> from Gwynedd Council, the RNLI & the RYA before taking to the water
            </p>
          </IonSlide>

          <IonSlide>
            <h2 className="slide-title">Safety on the Sands</h2>
            <p>
              <b>The currents around Portmadog can be dangerous</b>. Conditions can change quickly, and shifting sandbanks can leave you cut off by the sea - consult tide times before setting out, and be careful on an incoming tide
            </p>
          </IonSlide>

          <IonSlide>
            <h2 className="slide-title">Ready to View predictions?</h2>
            <IonButton fill="clear" onClick={startApp}>
              Continue
              <IonIcon slot="end" icon={arrowForward} />
            </IonButton>
          </IonSlide>
        </IonSlides>
      </IonContent>
    </IonPage>
  );
};

export default connect<OwnProps, {}, DispatchProps>({
  mapDispatchToProps: ({
    setHasSeenTutorial
  }),
  component: Tutorial
});
