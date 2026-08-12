import{c as i,p as l,s as c}from"./http-G4T0k7b1.js";import{a as e}from"./format-DV24c1nU.js";const n=document.getElementById("emi-form");if(n){const o=document.getElementById("emi-result"),a=document.getElementById("emi-breakdown");n.addEventListener("submit",async s=>{s.preventDefault(),i(n);const d=new FormData(n),m=Object.fromEntries(d.entries());try{const t=await l(n.dataset.action,m);document.getElementById("emi-monthly").textContent=e(t.emi),document.getElementById("emi-interest").textContent=e(t.total_interest),document.getElementById("emi-total").textContent=e(t.total_payment),a.innerHTML=t.yearly_breakdown.map(r=>`<tr>
                        <td class="py-2 pr-4">${r.year}</td>
                        <td class="py-2 pr-4">${e(r.principal_paid)}</td>
                        <td class="py-2 pr-4">${e(r.interest_paid)}</td>
                        <td class="py-2">${e(r.balance)}</td>
                    </tr>`).join(""),o.classList.remove("hidden"),o.scrollIntoView({behavior:"smooth",block:"nearest"})}catch(t){t.status===422&&c(t.errors)}})}
