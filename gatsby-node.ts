import TidalData from "./data/tides.json";
import path from "path";
import { TidesJson_PDFObject } from "./src/types";
import { CreatePagesArgs } from "gatsby";

export const createPages = async function ({
  actions,
  graphql,
}: CreatePagesArgs) {
  TidalData.pdfs.forEach((pdf: TidesJson_PDFObject) => {
    actions.createPage({
      path: "/tide-tables/" + pdf.url,
      component: path.resolve(`./src/components/templates/TideTablePage.tsx`),
      context: { pdf },
      defer: false,
    });
    actions.createRedirect({
      fromPath: "/tide-tables/" + pdf.url.replace("/", "-"),
      toPath: "/tide-tables/" + pdf.url,
    });
    actions.createRedirect({
      fromPath: "/tide-tables/" + pdf.url.replace("/", "-") + ".pdf",
      toPath: "/tide-tables/" + pdf.url + ".pdf",
    });
  });

  // Legacy page
  actions.createRedirect({
    fromPath: "/historical-tables",
    toPath: "/tide-tables",
  });
};
