import * as React from "react";
import {useState, useEffect} from "react";
import TidalData from "../../data/tides.json";
import { Link } from "gatsby";

const PDFs = (props) => {
  const [files, setFiles] = useState([]);
  useEffect(() => {
    setFiles([]);
    const month = new Date();
    month.setHours(0,0,0,0);
    month.setDate(1);
    const nextYear = new Date(month);
    nextYear.setFullYear(month.getFullYear() + 1);
    TidalData.pdfs.forEach(element => {
      let date = new Date(element.date);
      if (props.historical) {
        if (date < month) {
          setFiles(files => [...files, element]);
        }
      } else {
        if (date >= month && date <= nextYear) {
          setFiles(files => [...files, element]);
        }
      }      
    });
  }, []);

  return (
    <>
      <p className="text-3xl text-black mx-6 pt-4">
        {props.historical ? 
          props.lang == "en" ? "Historical PDF Tide Tables" : "Tablau Llanw PDF Hanesyddol"
          :
          props.lang == "en" ? "PDF Tide Tables" : "Tablau Llanw PDF"
        }
      </p>
      <div className="flex gap-4 px-4 pt-4 pb-7 flex-wrap">
        {files.map((element,index) => (<div className="bg-white shadow-lg rounded-3xl p-5 sm:p-7" key={index}><a href={"/tide-tables/" + element.filename}>{element.name}</a></div>))}
        {!props.historical && <div className="bg-white shadow-lg rounded-3xl p-5 sm:p-7 font-light"><Link to="historical-tables">{props.lang == "en" ? "Historical Tables":"Tablau Hanesyddol"}</Link></div>}
      </div>
    
    </>
  );
};

export default PDFs;
