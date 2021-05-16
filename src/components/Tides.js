import * as React from "react";
import {useState, useEffect} from "react";
import { DateTime } from "luxon";

import TidalData from "../../data/tides.json";

const Tides = (props) => {
  const [tides, setTides] = useState([]);
  useEffect(() => {
    setTides([]);
    const today = new Date();
    today.setHours(0,0,0,0);
    const nextWeek = new Date(today);
    nextWeek.setDate(today.getDate() + 7);
    TidalData.schedule.forEach(element => {
      let date = new Date(element.date);
      if (date >= today && date <= nextWeek) {
        setTides(tides => [...tides, element]);
      }
    });
  }, []);
  //{props.lang == "en" ? "Tides":"Welsh Tides"}
  return (
    <>
      <div className="flex flex-nowrap flew-row overflow-x-auto gap-4 px-4 py-10 ">
        {tides.map((element,index) => (
          <div className="bg-white shadow-lg sm:rounded-3xl sm:flex-grow sm:p-5" key={index}>
            <p>{DateTime.fromSQL(element.date).toLocaleString({ weekday: "long", day: "2-digit", month: "long" })}</p>
            {element.groups.map((element,index) => (
              <>
                <p>{element.time}</p>
                <p>{element.height}</p>
              </>
            ))}
          </div>
        ))}
      </div>
    </>
  );
};

export default Tides;
