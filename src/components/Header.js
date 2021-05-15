import * as React from "react";
import HtmlHead from "../components/HtmlHead.js";
import LanguageSelector from "../components/LanguageSelector.js";

const Header = (props) => {
  return (
    <>
      <HtmlHead lang={props.lang} />
      <LanguageSelector location={typeof window !== "undefined" ? location : false} lang={props.lang} />
    </>
  );
};

export default Header;
