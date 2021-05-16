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

  
  return (
    <>
      <p className="text-3xl text-black mx-6 pt-4">{props.lang == "en" ? "High Tides This Week":"Llanw Uchel Yr Wythnos Hon"}</p>
      <div className="flex flex-nowrap flew-row overflow-x-auto no-scrollbar gap-4 px-4 pb-3 pt-4">
        {tides.map((element,index) => (
          <div className="bg-white min-w-max shadow-lg rounded-3xl sm:flex-grow p-5" key={index}>
            <p className="text-base">{DateTime.fromSQL(element.date).toLocaleString({ weekday: "long", day: "2-digit", month: "long" })}</p>
            {element.groups.map(tide => (
              <>
                <p className="text-xl font-semibold inline-block">{DateTime.fromSQL(element.date + " " + tide.time).toLocaleString(DateTime.TIME_SIMPLE)}</p>
                <p className="text-lg font-light inline-block ml-3">{tide.height}m</p><br/>
              </>
            ))}
          </div>
        ))}
      </div>
    </>
  );
};

export default Tides;
