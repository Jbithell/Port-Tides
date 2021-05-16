import * as React from "react";

const Copyright = (props) => {
  return (
    <>
      <div className="p-4 bg-white bg-opacity-95">
        <p>{props.lang == "cy" ? "Yr amseroedd yw GMT/BST." : "Times are GMT/BST."} Tidal Predictions are provided for use by all water users though the developers of this site can not be held accountable for the accuracy of this data or any accidents that result from the use of this data.<br/>
          All Tidal Data is ©Crown Copyright. Reproduced by permission of the Controller of Her Majesty's Stationery Office and the UK Hydrographic Office (www.ukho.gov.uk). No tidal data may be reproduced without the expressed permission of the UKHO licencing department. {props.lang == "cy" ? "Gwefan, PDF ac App" : "PDFs, Website & App"} ©2014-2021 James Bithell</p>
      </div>
    </>
  );
};

export default Copyright;
