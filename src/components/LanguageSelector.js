import * as React from "react";
import { Link } from "gatsby";

const LanguageSelector = ({ lang, location }) => {
  if (lang === "en") {
    return (
      <Link to={"cy/" + location.pathname}>
        Welsh
      </Link>
    );
  } else {
    return (
      <Link
        to={location.pathname.replace("/" + lang, "/")}
      >
        English
      </Link>
    );
  }
};
export default LanguageSelector;