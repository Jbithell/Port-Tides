import * as React from "react";
import HtmlHead from "../components/HtmlHead.js";
import { Link } from "gatsby";

const Header = (props) => {
  return (
    <>
      <HtmlHead lang={props.lang} />
      <header className="text-center p-0 bg-opacity-75 bg-white flex flex-col sm:flex-row">
        <div className="flex-none text-4xl p-4 text-center sm:text-left">Porthmadog Tide Times</div>
        <div className="flex-grow"></div>
        <div className="flex-none">
          <div className="text-center sm:text-right text-4xl bg-white w-20 h-full overflow-auto shadow-lg sm:rounded-b-xl sm:p-0">
            <Link className="p-4" to={(props.lang === "en") ? (typeof window !== "undefined" ? "cy/" + location.pathname : "cy/") : (typeof window !== "undefined" ? location.pathname.replace("/" + props.lang, "/") : "/")}>
              {(props.lang === "en") ? "Cymraeg" : "English"}
            </Link>
          </div>
        </div>        
      </header>
    </>
  );
};

export default Header;
