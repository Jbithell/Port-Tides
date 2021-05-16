import * as React from "react";

const Footer = (props) => {
  return (
    <footer className="text-center p-2 bg-white shadow-lg flex flex-col sm:flex-row text-gray-700">
      <div className="text-center text-xl sm:text-left">
        <p>&copy; 2021 James Bithell</p>
      </div>
      <div className="flex-grow text-center"></div>
      <div className="text-center text-xl sm:text-right">
        <p></p>
      </div>
    </footer>
  );
};

export default Footer;
