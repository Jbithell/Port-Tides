import { IonItemDivider, IonItemGroup, IonLabel, IonList, IonListHeader, IonAlert, AlertButton } from '@ionic/react';
import React, { useState, useCallback } from 'react';
import moment from 'moment';
import { Schedule, Tide } from '../models/Schedule';
import SessionListItem from './SessionListItem';
import { connect } from '../data/connect';

interface OwnProps {
  schedule: Schedule[];
}

interface StateProps {
}

interface DispatchProps {
}

interface SessionListProps extends OwnProps, StateProps, DispatchProps { };

const SessionList: React.FC<SessionListProps> = ({ schedule }) => {

  const [showAlert, setShowAlert] = useState(false);
  const [alertHeader, setAlertHeader] = useState('');
  const [alertButtons, setAlertButtons] = useState<(AlertButton | string)[]>([]);

  const handleShowAlert = useCallback((header: string, buttons: AlertButton[]) => {
    setAlertHeader(header);
    setAlertButtons(buttons);
    setShowAlert(true);
  }, []);

  const currentDate = function () {
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    return yyyy +  '/' + mm + '/' + dd;
  }

  if (schedule.length === 0) {
    return (
      <IonList>
        <IonListHeader>
          No Tides Found
        </IonListHeader>
      </IonList>
    );
  }

  return (
    <>
      <IonList>
        {schedule.map((group, index: number) => (Date.parse(schedule[index].date + ' 00:00:00') >= Date.parse(currentDate() + ' 00:00:00')) && (Date.parse(schedule[index].date) < (Date.now()+(1000*60*60*24*365))) ? ( //Only show dates in the future or
          <IonItemGroup key={`group-${index}`}>
            <IonItemDivider sticky>
              <IonLabel>
                {moment(schedule[index].date).format('dddd Do MMMM YYYY')}
              </IonLabel>
            </IonItemDivider>
            {schedule[index].groups.map((session: Tide, sessionIndex: number) => (
              <SessionListItem
                session={session}
              />
            ))}
          </IonItemGroup>
        ) : '')}
      </IonList>
      <IonAlert
        isOpen={showAlert}
        header={alertHeader}
        buttons={alertButtons}
        onDidDismiss={() => setShowAlert(false)}
      ></IonAlert>
    </>
  );
};

export default connect<OwnProps, StateProps, DispatchProps>({
  mapStateToProps: (state) => ({
  }),
  mapDispatchToProps: ({
  }),
  component: SessionList
});
