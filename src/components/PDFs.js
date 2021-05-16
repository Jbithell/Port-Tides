import * as React from "react";
import {useState, useEffect} from "react";
import TidalData from "../../data/tides.json";


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
      if (date >= month && date <= nextYear) {
        setFiles(files => [...files, element]);
      }
    });
  }, []);

  //{props.lang == "en" ? "Tides":"Welsh Tides"}
  return (
    <>
      <div className="flex gap-4 px-4 py-10 flex-wrap">
        {files.map((element,index) => (<div className="bg-white shadow-lg rounded-3xl p-5 sm:p-7" key={index}><a href={"static/" + element.filename}>{element.name}</a></div>))}
      </div>
    </>
  );
};

export default PDFs;
