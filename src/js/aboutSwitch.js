function init() {
  const inDepth = document.getElementById("inDepth");
  const inBrief = document.getElementById("inBrief");
  const inDepthBtn = document.getElementById("inDepthBtn");
  const inBriefBtn = document.getElementById("inBriefBtn");
  const showInDepth = () => {
    inDepth.classList.remove("isHidden");
    inBrief.classList.add("isHidden");

    inDepthBtn.classList.add("isActive");
    inDepthBtn.setAttribute("aria-selected", "true");
    inBriefBtn.classList.remove("isActive");
    inBriefBtn.setAttribute("aria-selected", "false");
  };
  const showInBrief = () => {
    inDepth.classList.add("isHidden");
    inBrief.classList.remove("isHidden");

    inDepthBtn.classList.remove("isActive");
    inDepthBtn.setAttribute("aria-selected", "false");
    inBriefBtn.classList.add("isActive");
    inBriefBtn.setAttribute("aria-selected", "true");
  };

  inDepthBtn.addEventListener("click", showInDepth);
  inBriefBtn.addEventListener("click", showInBrief);
}

export default init;
