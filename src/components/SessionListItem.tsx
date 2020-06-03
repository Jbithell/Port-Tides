import React, { useRef } from 'react';
import { IonItemSliding, IonItem, IonLabel, IonNote } from '@ionic/react';
import { Tide } from '../models/Schedule';
import moment from 'moment';

interface SessionListItemProps {
  session: Tide;
}

const SessionListItem: React.FC<SessionListItemProps> = ({ session }) => {
  const ionItemSlidingRef = useRef<HTMLIonItemSlidingElement>(null)

  const dismissAlert = () => {
    ionItemSlidingRef.current && ionItemSlidingRef.current.close();
  }

  return (
    <IonItemSliding>
      <IonItem>
        <IonLabel>
          <h3>{moment('01 January 1970 ' + session.time).format('h:mma')}</h3>
        </IonLabel>
        <IonNote slot="end" color="primary">{session.height}m</IonNote>
      </IonItem>
    </IonItemSliding>
  );
};

export default React.memo(SessionListItem);
