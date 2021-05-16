import * as React from "react";
import HtmlHead from "../components/HtmlHead.js";
import { StaticImage } from "gatsby-plugin-image";
import { Link } from "gatsby";

const Header = (props) => {
  return (
    <>
      <HtmlHead lang={props.lang} />
      <StaticImage src="../images/porthmadogCobCrop.jpg" placeholder="blurred" alt="Porthmadog as seen from Borth-y-Gest" aspectRatio={16/2} />
      <header className="text-center p-0 bg-opacity-75 bg-white flex flex-col sm:flex-row">
        <div className="text-4xl p-4 text-center sm:text-left">{props.lang == "cy" ? "Amseroedd Llanw Porthmadog" : "Porthmadog Tide Times"}</div>
        <div className="flex-grow"></div>
        <div className="h-full">
          <Link className="text-center text-xl sm:text-4xl bg-white h-full sm:text-right shadow-lg rounded-lg m-10 p-2 sm:rounded-b-xl sm:px-3 sm:pt-5 sm:pb-3 sm:mr-5" to={(props.lang === "en") ? (typeof window !== "undefined" ? "/cy" + location.pathname : "cy/") : (typeof window !== "undefined" ? location.pathname.replace("/" + props.lang, "") : "/")}>
            {(props.lang === "en") ? "Cymraeg" : "English"}
          </Link> 
        </div>    
      </header>
    </>
  );
};

export default Header;
