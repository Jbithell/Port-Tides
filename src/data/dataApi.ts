import { Plugins } from '@capacitor/core';
import { Schedule, Tide } from '../models/Schedule';
import { PDF } from '../models/PDF';

const { Storage } = Plugins;

const dataUrl = 'https://cdn.port-tides.com/tides.json';

const HAS_SEEN_TUTORIAL = 'hasSeenTutorial';

export const getConfData = async () => {
 try {
   const response = await Promise.all([
     fetch(dataUrl, {
       method: "GET",
       headers: {
         "Content-Type": "text/json"
       }
     })]);
   const responseData = await response[0].json();
   const schedule = responseData.schedule as Schedule[];
   const tides = parseSessions(schedule);
   const pdfs = responseData.pdfs as PDF[];

   const data = {
     schedule,
     tides,
     pdfs
   }
   return data;
 } catch (error) {
   console.log(error);
   alert("Cannot connect to Network");
   return false;
 }
}

export const getUserData = async () => {
  const response = await Promise.all([
    Storage.get({ key: HAS_SEEN_TUTORIAL })
  ]);
  const hasSeenTutorial =  await response[0].value === 'true';
  const data = {
    hasSeenTutorial
  }
  return data;
}

export const setHasSeenTutorialData = async (hasSeenTutorial: boolean) => {
  await Storage.set({ key: HAS_SEEN_TUTORIAL, value: JSON.stringify(hasSeenTutorial) });
}

function parseSessions(schedule: Schedule[]) {
  return schedule;
}
