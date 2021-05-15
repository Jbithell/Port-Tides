import * as React from "react";
import { Link } from "gatsby";

const LanguageSelector = ({ lang, location }) => {
  if (lang === "en") {
    return (
      <Link to={typeof window !== "undefined" ? "cy/" + location.pathname : "cy/"}>
        Welsh
      </Link>
    );
  } else {
    return (
      <Link
        to={typeof window !== "undefined" ? location.pathname.replace("/" + lang, "/") : "/"}
      >
        English
      </Link>
    );
  }
};
export default LanguageSelector;