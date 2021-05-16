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


  return (
    <>
      {props.lang == "en" ? "Tides":"Welsh Tides"}
      {files.map((element,index) => (
        <a href={"static/" + element.filename} key={index}>{element.name}</a>
      ))} 
    </>
  );
};

export default PDFs;
