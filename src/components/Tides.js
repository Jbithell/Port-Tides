import * as React from "react";
import {useState, useEffect} from "react";
import TidalData from "../../data/tides.json";


const Tides = (props) => {
  const [tides, setTides] = useState([]);
  useEffect(() => {
    setTides([]);
    const today = new Date();
    today.setHours(0,0,0,0);
    const nextYear = new Date(today);
    nextYear .setFullYear(today.getFullYear() + 1);
    TidalData.schedule.forEach(element => {
      let date = new Date(element.date);
      if (date >= today && date <= nextYear) {
        setTides(tides => [...tides, element]);
      }
    });
  }, []);

  return (
    <>
      {props.lang == "en" ? "Tides":"Welsh Tides"}
      {tides.map((element,index) => (<li key={index}>{element.date}</li>))} 
    </>
  );
};

export default Tides;
